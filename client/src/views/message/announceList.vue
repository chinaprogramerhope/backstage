<template>
  <div>
    <!-- 表单 -->
    <el-form :inline="true" :model="form1" style="margin-top: 20px;" align="left">
      <el-form-item label="开始时间:">
        <el-date-picker
          v-model="form1.dpValue1"
          type="datetimerange"
          range-separator="~"
          start-placeholder="开始日期"
          end-placeholder="结束日期"
          value-format="yyyy-MM-dd HH:mm:ss"
        />
      </el-form-item>
      <el-form-item>
        <el-button type="primary" icon="el-icon-search" @click="handleSearch">搜索</el-button>
      </el-form-item>

      <el-form-item>
        <el-button @click="dialogFormVisible = true">+ 添加</el-button>
      </el-form-item>
    </el-form>

    <!-- dialog 添加公告 -->
    <el-dialog :visible.sync="dialogFormVisible" title="添加公告" center>
      <el-form :model="form2">
        <el-form-item :label-width="formLabelWidth" label="公告内容:">
          <el-input
            :rows="2"
            v-model="form2.content"
            type="textarea"
            placeholder="请输入公告内容"/>
        </el-form-item>

        <el-form-item :label-width="formLabelWidth" label="备注:">
          <el-input v-model="form2.note" autocomplete="off"/>
        </el-form-item>

        <el-form-item :label-width="formLabelWidth" label="公告状态">
          <el-select v-model="form2.selectStatus" placeholder="">
            <el-option
              v-for="item in form2.optionsAnnounceAddStatus"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            />
          </el-select>
        </el-form-item>

        <el-form-item :label-width="formLabelWidth" label="发送区域">
          <el-checkbox :indeterminate="isIndeterminate" v-model="checkAll" @change="handleCheckAllChange">全选</el-checkbox>
          <div style="margin: 15px 0;"/>
          <el-checkbox-group v-model="checkedAreas" @change="handleCheckedAreaChange">
            <el-checkbox v-for="area in areas" :label="area" :key="area">{{ area }}</el-checkbox>
          </el-checkbox-group>
        </el-form-item>

        <el-form-item :label-width="formLabelWidth" label="使用终端">
          <el-select v-model="form2.selectTerminal" placeholder="">
            <el-option
              v-for="item in form2.optionsAnnounceAddTerminal"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            />
          </el-select>
        </el-form-item>
      </el-form>

      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogFormVisible = false">取 消</el-button>
        <el-button type="primary" @click="dialogFormVisible = false">保 存</el-button>
      </div>
    </el-dialog>

    <!-- table -->
    <el-table
      :data="tableData"
      :default-sort="{prop: 'timeBegin', order:'descending'}"
      style="width: 100%; margin-bottom: 24px">
      <el-table-column prop="id" label="序号" align="center"/>
      <el-table-column prop="title" label="标题" align="center"/>
      <el-table-column prop="content" label="内容" align="center"/>
      <el-table-column prop="status" label="状态" align="center"/>
      <el-table-column prop="channel" label="渠道" align="center"/>
      <el-table-column prop="tag" label="Tag" align="center"/>
      <el-table-column prop="carousel" label="轮播" align="center"/>
      <el-table-column prop="creater" label="创建人" align="center"/>
      <el-table-column prop="note" label="备注" align="center"/>
      <el-table-column prop="publishTime" label="发布时间" align="center"/>
      <el-table-column prop="operate" label="操作" align="center">
        <template slot-scope="scope">
          <el-button type="primary" size="mini" @click="handleEdit">编辑</el-button>
          <el-button type="danger" size="mini" @click="handleDel">删除</el-button>
        </template>
      </el-table-column>
    </el-table>

    <!-- 分页 -->
    <el-pagination
      :current-page="currentPage"
      :page-sizes="[10, 20, 30, 40]"
      :page-size="10"
      :total="40"
      layout="total, sizes, prev, pager, next, jumper"
      align="center"
      @size-change="handleSizeChange"
      @current-change="handleCurrentChange"
    />

    <!-- dialog2 编辑公告 -->
    <el-dialog :visible.sync="dialog2FormVisible" title="编辑公告" center>
      <el-form :model="dialogForm2">
        <el-form-item :label-width="formLabelWidth" label="公告内容:">
          <el-input
            :rows="2"
            v-model="dialogForm2.content"
            type="textarea"
            placeholder="请输入公告内容"/>
        </el-form-item>

        <el-form-item :label-width="formLabelWidth" label="备注:">
          <el-input v-model="dialogForm2.note" autocomplete="off"/>
        </el-form-item>

        <el-form-item :label-width="formLabelWidth" label="公告状态">
          <el-select v-model="dialogForm2.selectStatus" placeholder="">
            <el-option
              v-for="item in dialogForm2.optionsAnnounceAddStatus"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            />
          </el-select>
        </el-form-item>

      </el-form>

      <div slot="footer" class="dialog-footer">
        <el-button @click="dialog2FormVisible = false">取 消</el-button>
        <el-button type="primary" @click="dialog2FormVisible = false">保 存</el-button>
      </div>
    </el-dialog>

  </div>
</template>

<script>
import { announceListGet } from '@/api/message'
import { announceListDel } from '@/api/message'

// checkbox 多选框
const areaOptions = ['收件箱', '走马灯']

export default {
  data() {
    return {

      form1: {
        dpValue1: '',
        gameRoom: '全部',
        vipAccount: ''
      },

      // tableData
      tableData: [{
        id: '2018-11-11 11:11:11',
        timeEnd: '2018-11-11 11:11:11',
        vipAccount: 'ok1',
        gameName: '牛牛1',
        gameRoom: '初级房',
        bet: 11.11,
        winAmount: 11.11,
        winLose: 11.11,
        tax: 11.11
      }, {
        timeBegin: '2018-11-11 11:11:12',
        timeEnd: '2018-11-11 11:11:12',
        vipAccount: 'ok2',
        gameName: '牛牛2',
        gameRoom: '初级房',
        bet: 11.12,
        winAmount: 11.12,
        winLose: 11.12,
        tax: 11.12
      }],

      // 分页
      currentPage: 4,

      // dialog 添加公告
      dialogFormVisible: false,
      form2: {
        content: '',
        note: '',
        selectStatus: 1,
        selectTerminal: -1,

        optionsAnnounceAddStatus: [{
          label: '启用',
          value: 1
        }, {
          label: '禁用',
          value: 2
        }],

        optionsAnnounceAddTerminal: [{
          label: '全部',
          value: -1
        }, {
          label: '电脑端',
          value: 1
        }, {
          label: '移动端',
          value: 2
        }]
      },

      // checkbox 多选框
      checkAll: false,
      checkedAreas: [],
      areas: areaOptions,
      isIndeterminate: true,

      formLabelWidth: '120px',

      // dialog2 编辑公告
      dialog2FormVisible: false,
      dialogForm2: {
        content: '',
        note: '',
        selectStatus: 1,

        optionsAnnounceAddStatus: [{
          label: '启用',
          value: 1
        }, {
          label: '禁用',
          value: 2
        }]
      }
    }
  },
  created() {
    this.announceListGetClient(this.form1.selectAnnounceType, this.form1.dpValue1)
  },
  methods: {
    announceListGetClient(type, timeBegin) {
      announceListGet(type, timeBegin).then(response => {
        this.tableData = response.data
        // test
        console.log('tableDataType = ' + typeof (response.data) + ', value = ' + JSON.stringify(response.data))
      })
    },

    handleSearch() {
      this.announceListGetClient(this.form1.selectAnnounceType, this.form1.dpValue1)
    },

    // 编辑公告
    handleEdit() {
      this.dialog2FormVisible = true
    },

    // 删除公告
    handleDel(announceId) {
      announceListDel(announceId).then(response => {
        if (response.code === 0) {
          this.$notify({
            title: '删除公告成功',
            message: '',
            type: 'success'
          })
        } else {
          this.$notify({
            title: '删除公告失败',
            message: '',
            type: 'error'
          })
        }
      })
    },

    // 分页
    handleSizeChange(val) {

    },
    handleCurrentChange(val) {

    },

    // checkbox 多选框
    handleCheckAllChange(val) {
      this.checkedAreas = val ? areaOptions : []
      this.isIndeterminate = false
    },
    handleCheckedAreaChange(val) {
      const checkedCount = val.length
      this.checkAll = checkedCount === this.areas.length
      this.isIndeterminate = checkedCount > 0 && checkedCount < this.areas.length
    }
  }
}
</script>
