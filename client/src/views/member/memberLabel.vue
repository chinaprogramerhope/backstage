<template>
  <div>

    <el-row align="left" style="margin-top: 30px">
      <el-button type="primary" size="mini" @click="dialogFormAddVisible = true">添加</el-button>
    </el-row>

    <!-- 表格 -->
    <el-table
      :data="tableData"
      :default-sort="{prop: 'timeBegin', order:'descending'}"
      style="width: 100%; margin-bottom: 24px"
      stripe
    >
      <el-table-column prop="name" label="标签名称" align="center" sortable/>
      <el-table-column prop="sort" label="排序" align="center" sortable/>
      <el-table-column prop="personNum" label="人数" align="center" sortable/>
      <el-table-column prop="operation" label="操作" align="center">
        <template slot-scope="scope">
          <el-row :gutter="40">
            <el-col :span="6">
              <el-button size="mini" @click="handleOpenEdit(scope.row.name)">编辑</el-button>
            </el-col>
            <el-col :span="6">
              <el-button size="mini" type="danger" @click="handleDel(scope.row.name)">删除</el-button>
            </el-col>
          </el-row>

        </template>
      </el-table-column>
    </el-table>

    <!-- 分页 -->
    <!-- <el-pagination
      :current-page="currentPage"
      :page-sizes="[10, 20, 30, 40]"
      :page-size="10"
      :total="40"
      align="center"
      layout="total, sizes, prev, pager, next, jumper"
      @size-change="handleSizeChange"
      @current-change="handleCurrentChange"
    /> -->

    <!-- dialogAdd 添加 -->
    <el-dialog :visible.sync="dialogFormAddVisible" title="添加标签">
      <el-form :model="dialogFormAdd">

        <el-form-item
          :label-width="dialogLabelWidth"
          :rules="[
            { required: true, message: '请输入标签名称', trigger: 'blur' }
          ]"
          label="标签名称:"
          prop="name"
        >
          <el-input v-model="dialogFormAdd.name" autocomplete="off"/>
        </el-form-item>

        <el-form-item :label-width="dialogLabelWidth" label="自动出款:">
          <el-select v-model="dialogFormAdd.selectAutoMoney" placeholder="">
            <el-option
              v-for="item in dialogFormAdd.optionsAutoMoney"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            />
          </el-select>
        </el-form-item>

        <el-form-item
          :label-width="dialogLabelWidth"
          :rules="[
            { required: true, message: '请输入排序值', trigger: 'blur' }
          ]"
          label="排序:"
          prop="sort"
        >
          <el-input v-model="dialogFormAdd.sort" autocomplete="off"/>
        </el-form-item>

        <el-form-item align="center">
          <el-button @click="dialogFormAddVisible = false">取 消</el-button>
          <el-button type="primary" @click="handleAdd()">确 定</el-button>
        </el-form-item>

      </el-form>
    </el-dialog>

    <!-- dialogEdit 编辑 -->
    <el-dialog :visible.sync="dialogFormEditVisible" title="编辑标签">
      <el-form :model="dialogFormEdit">

        <el-form-item
          :label-width="dialogLabelWidth"
          :rules="[
            { required: true, message: '请输入标签名称', trigger: 'blur' }
          ]"
          label="标签名称:"
          prop="name"
        >
          <el-input v-model="dialogFormEdit.name" autocomplete="off"/>
        </el-form-item>

        <el-form-item :label-width="dialogLabelWidth" label="自动出款:">
          <el-select v-model="dialogFormEdit.selectAutoMoney" placeholder="">
            <el-option
              v-for="item in dialogFormEdit.optionsAutoMoney"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            />
          </el-select>
        </el-form-item>

        <el-form-item
          :label-width="dialogLabelWidth"
          :rules="[
            { required: true, message: '请输入排序值', trigger: 'blur' }
          ]"
          label="排序:"
          prop="sort"
        >
          <el-input v-model="dialogFormEdit.sort" autocomplete="off"/>
        </el-form-item>

        <el-form-item align="center">
          <el-button @click="dialogFormEditVisible = false">取 消</el-button>
          <el-button type="primary" @click="handleEdit()">确 定</el-button>
        </el-form-item>

      </el-form>
    </el-dialog>

  </div>
</template>

<script>
import { getLabel } from '@/api/member'
import { addLabel } from '@/api/member'
import { editLabel } from '@/api/member'
import { delLabel } from '@/api/member'

export default {
  data() {
    return {
      form1: {
        name: '',
        selectAutoMoney: '是',
        sort: '',
        optionsAutoMoney: [{
          label: '是',
          value: 'yes'
        }, {
          label: '否',
          value: 'no'
        }]
      },
      dialogLabelWidth: '120px',

      dialogFormAddVisible: false,
      dialogFormAdd: {
        name: '',
        selectAutoMoney: 1,
        optionsAutoMoney: [{
          label: '是',
          value: 1
        }, {
          label: '否',
          value: 2
        }],
        sort: ''
      },

      dialogFormEditVisible: false,
      dialogFormEdit: {
        id: 0,
        name: '',
        selectAutoMoney: 1,
        optionsAutoMoney: [{
          label: '是',
          value: 1
        }, {
          label: '否',
          value: 2
        }],
        sort: ''
      },

      // tableData
      tableData: '',

      // 分页
      currentPage: 1
    }
  },

  created() {
    // 获取
    getLabel().then(response => {
      if (response.code === 0) {
        this.tableData = response.data
      } else {
        this.$notify({
          title: '获取数据失败: ' + response.msg,
          message: '',
          type: 'error'
        })
      }
    })
  },

  methods: {

    // 获取
    handleGet() {
      getLabel().then(response => {
        if (response.code === 0) {
          this.tableData = response.data
        } else {
          this.$notify({
            title: '获取数据失败: ' + response.msg,
            message: '',
            type: 'error'
          })
        }
      })
    },

    // dialog 添加标签
    handleAdd() {
      this.dialogFormAddVisible = true

      const name = this.dialogFormAdd.name
      const autoMoney = this.dialogFormAdd.selectAutoMoney
      const sort = this.dialogFormAdd.sort

      addLabel(name, autoMoney, sort).then(response => {
        if (response.code === 0) {
          this.$notify({
            title: '添加标签成功',
            message: '',
            type: 'success'
          })

          this.dialogFormAddVisible = false

          this.handleGet()
        } else {
          this.$notify({
            title: '添加标签失败: ' + response.msg,
            message: '',
            type: 'error'
          })
        }
      })
    },

    // 打开编辑dialog
    handleOpenEdit(name) {
      this.dialogFormEditVisible = true
      var theRow = ''

      for (const v in this.tableData) {
        if (this.tableData[v].name === name) {
          theRow = this.tableData[v]
          break
        }
      }

      this.dialogFormEdit.id = theRow.id
      this.dialogFormEdit.name = theRow.name
      this.dialogFormEdit.autoMoney = Number(theRow.autoMoney)
      this.dialogFormEdit.sort = theRow.sort
    },

    // dialog 编辑标签
    handleEdit() {
      const id = this.dialogFormEdit.id
      const name = this.dialogFormEdit.name
      const autoMoney = this.dialogFormEdit.selectAutoMoney
      const sort = this.dialogFormEdit.sort

      editLabel(id, name, autoMoney, sort).then(response => {
        if (response.code === 0) {
          this.$notify({
            title: '编辑标签成功',
            message: '',
            type: 'success'
          })

          this.dialogFormEditVisible = false

          this.handleGet()
        } else {
          this.$notify({
            title: '编辑标签失败: ' + response.msg,
            message: '',
            type: 'error'
          })
        }
      })
    },

    // dialog 删除标签
    handleDel(name) {
      delLabel(name).then(response => {
        if (response.code === 0) {
          this.$notify({
            title: '删除标签成功',
            message: '',
            type: 'success'
          })

          this.dialogFormEditVisible = false

          this.handleGet()
        } else {
          this.$notify({
            title: '删除标签失败: ' + response.msg,
            message: '',
            type: 'error'
          })
        }
      })
    },

    // dialog
    submitRuleForm(formName) {
      this.$refs[formName].validate((valid) => {
        if (valid) {
          alert('submit!')
        } else {
          this.$notify({
            title: '检验不通过, 请检查错误提示',
            message: '',
            type: 'warning'
          })
        }
      })
    }
  }
}
</script>
